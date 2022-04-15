import {Login} from '../Login.js';
import {baseURL} from '../../src/config.js';

export class DeleteOffer extends Login {

    constructor(delete_url)
    {
        super('DeleteOffer')
        this.delete_url = delete_url
    }

    DeleteOffer()
    {
        axios.delete(baseURL + this.delete_url)
            .then((response) => {
                console.log(response);
            })
            .catch( (error) => {
                console.log(error);
            });
    }
}

