import { Hono } from 'hono'
import * as filesystem from './filesystem'
import { randomFilename } from './filename'

const app = new Hono()

/**
 * Dump the requested file to the response.
 * @route GET *
 */
app.get('*', async (c) => {
    const url = new URL(c.req.url)
    return c.text(await filesystem.readFile(url.pathname))
})

/**
 * Write the file into the file system.
 * @route PUT *
 */
app.put('*', async (c) => {
    const url = new URL(c.req.url)
    await filesystem.writeFile(url.pathname, await c.req.text())
    return c.text('')
})

/**
 * Write a randomly generated file into the file system.
 * Returns the filename into the response Location header.
 * @route POST /
 */
app.post('/', async (c) => {
    const filename = randomFilename()
    await filesystem.writeFile(filename, await c.req.text())
    c.res.headers.append('Location', filename)
    return c.text('')
})

/**
 * Delete the file from the file system.
 * @route DELETE *
 */
app.delete('*', async (c) => {
    const url = new URL(c.req.url)
    await filesystem.deleteFile(url.pathname)
    return c.text('')
})

export default app
