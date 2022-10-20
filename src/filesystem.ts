import * as path from 'path'
import fs from 'fs-extra'

const dataDir = process.env.SOL_DATA_DIR || 'var/data'


/**
 * Returns the content of a stored file.
 * @param file
 */
export const readFile = async (file: string) => {
    return await fs.readFile(path.join(dataDir, file), 'utf-8')
}

/**
 * Write the file into the file system.
 * If the file already exists, throw an error.
 * If it ends with a slash, throw an error.
 *
 * @param file
 * @param data
 */
export const writeFile = async (file: string, data: string) => {
    if (file.endsWith('/')) {
        throw new Error('Cannot write a directory')
    }

    const filePath = path.join(dataDir, file)

    if (await fs.pathExists(filePath)) {
        throw new Error('Document already exists')
    }

    await fs.mkdir(path.dirname(filePath), { recursive: true })
    await fs.writeFile(filePath, data)
}

/**
 * Delete the file from the file system.
 * If it ends with a slash, throw an error.
 * If the file does not exist, throw an error.
 *
 * @param file
 */
export const deleteFile = async (file: string) => {
    if (file.endsWith('/')) {
        throw new Error('Cannot delete a directory')
    }

    await fs.unlink(path.join(dataDir, file))
}
