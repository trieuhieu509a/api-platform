import {baseURL} from '../src/config.js'
import {email} from '../src/config.js'
import {password} from '../src/config.js'

export class Login {

    constructor(action = null)
    {
        if(action !== null)
        {
            this.sendTokenHeader().then( () => {
                eval("this."+action+"()")
            } )
        }
    }

    login()
    {
        this.getJWTToken()
    }

    sendTokenHeader()
    {
        return new Promise ( (resolve) => {
            axios.defaults.headers.common = {
                'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')
            }
            resolve()
        } )
    }

    getJWTToken() // login
    {
        return new Promise( (resolve) => {

            let params = {
                "email": email,
                "password": password
            }

            let config = {
                headers: {
                    'accept': 'application/json',
                }
            }

            axios.post(baseURL+'/authentication_token', params, config)
                .then((response) => {
                    localStorage.setItem("jwt_token", response.data.token)
                    localStorage.setItem("user_id", response.data.id)
                    // console.log(response.data.token);
                }).catch((error) => {
                // console.log(error)
            })
            resolve()
        } )


    }

    logout()
    {
        return new Promise( (resolve) => {
            localStorage.removeItem('jwt_token')
            localStorage.removeItem('user_id')
            resolve()
        } )
    }

    handle401Error()
    {
        let p = document.getElementById("needs-login");
        p.style.display = 'block';
        let a = document.createElement('a');
        a.style.color = "#FF0000"
        let linkText = document.createTextNode("Invalid authorization, click to login");
        a.appendChild(linkText);
        a.href = "#"
        p.appendChild(a);
        document.body.appendChild(p);
    }

}