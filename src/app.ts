import { Hono } from 'hono'
import * as filesystem from './filesystem'

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
 * @route POST *
 */
app.post('*', async (c) => {
    const url = new URL(c.req.url)
    await filesystem.writeFile(url.pathname, await c.req.text())
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
