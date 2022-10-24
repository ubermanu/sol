import type { StorageInterface } from '../storage'

const data = {}

const storage: StorageInterface = {
    read: async (resource: string) => data[resource] ?? null,
    exists: async (resource: string) => resource in data,
    write: async (resource: string, data: string) => {
        data[resource] = data
    },
    delete: async (resource: string) => {
        delete data[resource]
    }
}

export default storage
