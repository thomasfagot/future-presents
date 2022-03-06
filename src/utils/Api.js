import axios from 'axios'

let apiConfig = {
    baseURL: 'http://localhost/api',
    withCredentials: true,
}
const instance = axios.create(apiConfig)
const instanceRefresh = axios.create(apiConfig)

instance.interceptors.response.use(
    function (response) {
        return response
    },
    function (error) {
        if (error.response && 401 === error.response.status) {
            return resetTokenAndReattemptRequest(error)
        }
        return Promise.reject(error)
    }
)

let isAlreadyFetchingAccessToken = false
const subscribers = [] // This is the list of waiting requests that will retry after the JWT refresh complete

async function resetTokenAndReattemptRequest(error) {
    try {
        const { response: errorResponse } = error
        const retryOriginalRequest = new Promise((resolve) => {
            addSubscriber(() => resolve(axios(errorResponse.config)))
        })
        if (!isAlreadyFetchingAccessToken) {
            isAlreadyFetchingAccessToken = true
            const response = await instanceRefresh.post('/refresh-token')
            if (!response.data || 200 !== response.status) {
                return Promise.reject(error)
            }
            isAlreadyFetchingAccessToken = false
            onAccessTokenFetched()
        }
        return retryOriginalRequest
    } catch (err) {
        return Promise.reject(err)
    }
}

function onAccessTokenFetched() {
    subscribers.forEach((callback) => callback())
    subscribers.splice(0, subscribers.length)
}

function addSubscriber(callback) {
    subscribers.push(callback)
}

export default instance
