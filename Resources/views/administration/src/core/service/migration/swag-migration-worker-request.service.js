/**
 * Describes the current API endpoint.
 * Can be easily used together with the MIGRATION_STATUS.
 *
 * Example to get the API operation from status:
 * WORKER_API_OPERATION[MIGRATION_STATUS.FETCH_DATA]
 *
 * @type {Readonly<{"0": string, "1": string, "2": string}>}
 */
export const WORKER_API_OPERATION = Object.freeze({
    0: 'fetchData',
    1: 'writeData',
    2: 'downloadAssets'
});

export class WorkerRequest {
    /**
     * @param {number} status
     * @param {Object} requestParams
     * @param {WorkerStatusManager} workerStatusManager
     * @param {MigrationApiService} migrationService
     * @param {function} onProgressCB
     * @param {function} onErrorCB
     */
    constructor(
        status,
        requestParams,
        workerStatusManager,
        migrationService,
        onProgressCB,
        onErrorCB
    ) {
        this._MAX_REQUEST_TIME = 10000; // in ms
        this._DEFAULT_CHUNK_SIZE = 50; // in data sets
        this._CHUNK_INCREMENT = 5; // in data sets
        this.__MIN_INCREMENT = this._CHUNK_INCREMENT;

        this._runId = requestParams.runUuid;
        this._status = status;
        this._requestParams = requestParams;
        this._workerStatusManager = workerStatusManager;
        this._migrationService = migrationService;
        this._interrupt = false;
        this._chunkSize = this._DEFAULT_CHUNK_SIZE;

        // callbacks
        this._onProgressCB = onProgressCB;
        this._onErrorCB = onErrorCB;
    }

    /**
     * @returns {number}
     */
    get status() {
        return this._status;
    }

    /**
     * @param {number} value
     */
    set status(value) {
        this._status = value;
    }

    /**
     * @returns {string}
     */
    get operation() {
        return WORKER_API_OPERATION[this._status];
    }

    /**
     * @returns {boolean}
     */
    get interrupt() {
        return this._interrupt;
    }

    /**
     * @param {boolean} value
     */
    set interrupt(value) {
        this._interrupt = value;
    }

    /**
     * @param {function} value
     */
    set onProgressCB(value) {
        this._onProgressCB = value;
    }

    /**
     * @param {function} value
     */
    set onErrorCB(value) {
        this._onErrorCB = value;
    }

    /**
     * @param {Object} param
     * @private
     */
    _callProgressCB(param) {
        if (this._onProgressCB !== null) {
            this._onProgressCB(param);
        }
    }

    /**
     * @param {Object} param
     * @private
     */
    _callErrorCB(param) {
        if (this._onErrorCB !== null) {
            this._onErrorCB(param);
        }
    }

    /**
     * Do all the API requests for all entities with the given methodName
     *
     * @param {Object} entityGroups
     * @param {number} groupStartIndex
     * @param {number} entityStartIndex
     * @param {number} entityOffset
     * @returns {Promise}
     */
    async migrateProcess(entityGroups, groupStartIndex = 0, entityStartIndex = 0, entityOffset = 0) {
        /* eslint-disable no-await-in-loop */
        return new Promise(async (resolve) => {
            await this._workerStatusManager.onStatusChanged(
                this._runId,
                entityGroups,
                this._status
            ).then(([newEntityGroups]) => {
                entityGroups = newEntityGroups;
            });

            for (let groupIndex = groupStartIndex; groupIndex < entityGroups.length; groupIndex += 1) {
                let groupProgress = 0;
                for (let entityIndex = 0; entityIndex < entityGroups[groupIndex].entities.length; entityIndex += 1) {
                    if (this._interrupt) {
                        resolve();
                        return;
                    }

                    const entityName = entityGroups[groupIndex].entities[entityIndex].entityName;
                    const entityCount = entityGroups[groupIndex].entities[entityIndex].entityCount;

                    if (entityIndex >= entityStartIndex) {
                        await this._migrateEntity(
                            entityName,
                            entityCount,
                            entityGroups[groupIndex],
                            groupProgress,
                            entityOffset
                        );

                        entityOffset = 0;
                    }

                    groupProgress += entityCount;
                }
                entityStartIndex = 0;
            }

            resolve();
        });
        /* eslint-enable no-await-in-loop */
    }

    /**
     * Do all the API requests for one entity in chunks
     *
     * @param {string} entityName
     * @param {number} entityCount
     * @param {Object} group
     * @param {number} groupProgress
     * @param {number} currentOffset
     * @returns {Promise<void>}
     * @private
     */
    async _migrateEntity(entityName, entityCount, group, groupProgress, currentOffset = 0) {
        /* eslint-disable no-await-in-loop */
        while (currentOffset < entityCount) {
            if (this._interrupt) {
                return;
            }

            const oldChunkSize = this._chunkSize;
            await this._migrateEntityRequest(entityName, group.targetId, group.target, currentOffset);
            let newOffset = currentOffset + oldChunkSize;
            if (newOffset > entityCount) {
                newOffset = entityCount;
            }

            // call event subscriber
            group.progress = groupProgress + newOffset;
            this._callProgressCB({
                entityName,
                entityGroupProgressValue: group.progress,
                entityCount: group.count
            });

            currentOffset += oldChunkSize;
        }
        /* eslint-enable no-await-in-loop */

        this._chunkSize = this._DEFAULT_CHUNK_SIZE;
    }

    /**
     * Do a single API request for the given entity with given offset.
     *
     * @param {string} entityName
     * @param {string} targetId
     * @param {string} target
     * @param {number} offset
     * @returns {Promise}
     * @private
     */
    _migrateEntityRequest(entityName, targetId, target, offset) {
        return new Promise((resolve) => {
            this._requestParams.entity = entityName;
            this._requestParams.offset = offset;
            this._requestParams.limit = this._chunkSize;

            if (target === 'catalog') {
                this._requestParams.catalogId = targetId;
            } else {
                this._requestParams.salesChannelId = targetId;
            }

            const beforeRequestTime = new Date();
            this._migrationService[this.operation](this._requestParams).then((response) => {
                if (!response) {
                    this._callErrorCB({
                        code: '0',
                        detail: this.applicationRoot.$i18n.tc('swag-migration.index.error.canNotConnectToServer.detail'),
                        status: '444',
                        title: this.applicationRoot.$i18n.tc('swag-migration.index.error.canNotConnectToServer.title'),
                        information: this.applicationRoot.$i18n.tc(
                            'swag-migration.index.error.canNotConnectToServer.information'
                        ),
                        trace: []
                    });
                    resolve();
                    return;
                }

                const afterRequestTime = new Date();
                this._handleChunkSize(afterRequestTime.getTime() - beforeRequestTime.getTime());
                resolve();
            }).catch((response) => {
                if (!response || !response.response) {
                    this._callErrorCB({
                        code: '0',
                        detail: this.applicationRoot.$i18n.tc('swag-migration.index.error.canNotConnectToServer.detail'),
                        status: '444',
                        title: this.applicationRoot.$i18n.tc('swag-migration.index.error.canNotConnectToServer.title'),
                        information: this.applicationRoot.$i18n.tc(
                            'swag-migration.index.error.canNotConnectToServer.information'
                        ),
                        trace: []
                    });
                    resolve();
                    return;
                }

                if (response.response.data && response.response.data.errors) {
                    response.response.data.errors.forEach((error) => {
                        this._callErrorCB(error);
                    });
                }

                const afterRequestTime = new Date();
                this._handleChunkSize(afterRequestTime.getTime() - beforeRequestTime.getTime());
                resolve();
            });
        });
    }

    /**
     * Update the chunkSize depending on the requestTime
     *
     * @param {number} requestTime Request time in milliseconds
     * @private
     */
    _handleChunkSize(requestTime) {
        if (requestTime < this._MAX_REQUEST_TIME) {
            this._chunkSize += this._CHUNK_INCREMENT;
        }

        if (
            requestTime > this._MAX_REQUEST_TIME &&
            (this._chunkSize - this._CHUNK_INCREMENT) >= this.__MIN_INCREMENT
        ) {
            this._chunkSize -= this._CHUNK_INCREMENT;
        }
    }
}

export default WorkerRequest;