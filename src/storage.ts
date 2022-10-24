import filesystemStorage from './storage/filesystem'
import memoryStorage from './storage/memory'
import noneStorage from './storage/none'

/**
 * Storage adapter interface.
 */
export interface StorageInterface {
    exists(resource: string): Promise<boolean>
    read(resource: string): Promise<string>
    write(resource: string, data: string): Promise<void>
    delete(resource: string): Promise<void>
}

/**
 * Storage string to adapter.
 * @param storage
 */
export const createStorage = (storage: string): StorageInterface => {
    switch (storage) {
        case 'file':
            return filesystemStorage
        case 'memory':
            return memoryStorage
        case 'none':
        default:
            return noneStorage
    }
}
