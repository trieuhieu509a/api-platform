
import {baseURL} from '../../src/config.js';

export class AddOffer  {


    AddOffer(url,price,priceCurrency,product_id)
    {
        let params = {
            "url": url,
            "price": price,
            "priceCurrency": priceCurrency,
            "product": "api/products/"+product_id
        }

        let config = {
            headers: {
                'accept': 'application/ld+json',
                "Content-Type": "application/ld+json"
            }
        }

        axios.post(baseURL+'/api/offers', params, config)
            .then((response) => {
                console.log(response);
            }).catch((error) => {
            console.log(error)
        })
    }

}
