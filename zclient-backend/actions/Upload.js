import {Login} from './Login.js';

export class Upload extends Login  {

    constructor(files,product_id)
    {
        super('Upload')
        this.files = files
        this.product_id = product_id
    }

    Upload()
    {
        console.log(this.files, this.product_id)

    }

}
