import randomWords from 'random-words'

/**
 * Returns a randomly generated filename (made of words).
 */
export const randomFilename = () => {
    return randomWords({ exactly: 6, join: '-' })
}
