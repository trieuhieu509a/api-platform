import {baseURL} from '../../src/config.js';


export class DeleteOffer {

    constructor()
    {
        axios.defaults.headers.common = {
            'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
        }
    }

    DeleteOffer(delete_url)
    {
        axios.delete(baseURL + delete_url)
            .then((response) => {
                console.log(response);
            })
            .catch( (error) => {
                console.log(error);
            });
    }
}
