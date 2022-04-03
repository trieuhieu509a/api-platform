import { baseURL } from './config.js';
import { show } from './view.js';
import { pagination } from './pagination.js';
import { router } from './router.js';

export const getData = (event) => {

    axios.get(baseURL + router(event))
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
