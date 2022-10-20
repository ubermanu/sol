import { Hono } from 'hono'

const app = new Hono()

/**
 * Dump the requested file to the response.
 * @route GET /
 */
app.get('*', (c) => {
    const url = new URL(c.req.url)
    return c.text(url.pathname)
})

app.post('*', (c) => c.text(c.req.url))

app.patch('*', (c) => c.text(c.req.url))
app.delete('*', (c) => c.text(c.req.url))

export default app
