/**
 * Storage adapter interface.
 */
export interface StorageInterface {
    exists(resource: string): Promise<boolean>;
    read(resource: string): Promise<string>;
    write(resource: string, data: string): Promise<void>;
    delete(resource: string): Promise<void>;
}
