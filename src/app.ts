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
    await filesystem.writeFile(url.pathname, c.req.body.toString())
    return c.text('')
})

/**
 * Delete the file from the file system.
 * @route DELETE *
 */
app.delete('*', (c) => {
    const url = new URL(c.req.url)
    return c.text(url.pathname)
})

export default app
