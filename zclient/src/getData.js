import { baseURL } from './config.js';
import { show } from './view.js';
import { pagination } from './pagination.js';


export const getData = (event) => {

    if(typeof event.target.nextLink !== 'undefined')
        var url = event.target.nextLink
    else
        var url = '/api/products'
    axios.get(baseURL + url)
        .then(function (response) {
            pagination(response.data);
            show(response.data['hydra:member']);
            // console.log(response.data);
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        });

}
