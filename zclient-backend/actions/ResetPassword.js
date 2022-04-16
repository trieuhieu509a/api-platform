import {baseURL} from '../src/config.js'
import {email} from '../src/config.js'

export class ResetPassword {

    makeRequest()
    {

        let params = {
            "email": email
        }

        let config = {
            headers: {
                'accept': 'application/json',
                "Content-Type": "application/json"
            }
        }

        return axios.post(baseURL+'/api/users/reset-password', params, config)
            .then((response) => {
                return response.data
            }).catch((error) => {

            })

    }

}