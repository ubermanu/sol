import { Hono } from 'hono'
import mime from 'mime-types'
import storage from './storage/filesystem'
import { randomFilename } from './filename'

const app = new Hono()

/**
 * Placeholder to indicate the health of the server.
 * @route GET /
 */
app.get('/', (c) => c.text('Your SOL server is running!'))

/**
 * Dump the requested file to the response.
 * @route GET *
 */
app.get('*', async (c) => {
    const url = new URL(c.req.url)

    if (!await storage.exists(url.pathname)) {
        return c.notFound()
    }

    c.header('Content-Type', mime.contentType(url.pathname) || 'text/plain')
    return c.body(await storage.read(url.pathname))
})

/**
 * Write the file into the file system.
 * @route PUT *
 */
app.put('*', async (c) => {
    const url = new URL(c.req.url)

    if (await storage.exists(url.pathname)) {
        return c.text('Document already exists', 409)
    }

    await storage.write(url.pathname, await c.req.text())
    return c.text('')
})

/**
 * Write a randomly generated file into the file system.
 * Returns the filename into the response Location header.
 * The extension is determined by the Content-Type header.
 *
 * @route POST /
 */
app.post('/', async (c) => {
    let filename = randomFilename()
    const ext = mime.extension(c.req.headers.get('content-type'))

    if (ext) {
        filename += '.' + ext
    }

    await storage.write(filename, await c.req.text())
    c.header('Location', filename)

    return c.text('')
})

/**
 * Delete the file from the file system.
 * @route DELETE *
 */
app.delete('*', async (c) => {
    const url = new URL(c.req.url)

    if (!await storage.exists(url.pathname)) {
        return c.notFound()
    }

    await storage.delete(url.pathname)
    return c.text('')
})

/**
 * Returns the options for the requested file.
 * @route OPTIONS *
 */
app.options('*', async (c) => {
    const url = new URL(c.req.url)
    const methods = ['OPTIONS']

    // We can post only to the root.
    if (url.pathname === '/') {
        methods.push('POST')
    } else {
        if (await storage.exists(url.pathname)) {
            methods.concat(['GET', 'DELETE'])
        } else {
            methods.push('PUT')
        }
    }

    c.header('Access-Control-Allow-Origin', '*')
    c.header('Access-Control-Allow-Methods', methods.join(', '))
    c.header('Access-Control-Allow-Headers', 'Content-Type')

    return c.text('')
})

export default app
