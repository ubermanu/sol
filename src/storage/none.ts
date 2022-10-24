import type { StorageInterface } from '../storage'

const storage: StorageInterface = {
    read: async (resource: string) => null,
    exists: async (resource: string) => false,
    write: async (resource: string, data: string) => {},
    delete: async (resource: string) => {}
}

export default storage
