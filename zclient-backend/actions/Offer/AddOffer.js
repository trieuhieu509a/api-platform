import {Login} from '../Login.js';
import {baseURL} from '../../src/config.js';


export class AddOffer extends Login  {

    constructor(url,price,priceCurrency,product_id)
    {
        super('AddOffer')
        this.url = url
        this.price = price
        this.priceCurrency = priceCurrency
        this.productID = product_id
    }

    AddOffer()
    {
        let params = {
            "url": this.url,
            "price": this.price,
            "priceCurrency": this.priceCurrency,
            "product": "api/products/"+this.productID
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
