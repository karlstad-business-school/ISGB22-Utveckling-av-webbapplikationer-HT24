import { Component } from "react";

class Main extends Component {

    constructor(props) {
        super(props);

        this.state = {
            translation : ''
        };
    }


    render() {
        return(
            <main>
                <h2>Skriv in text att skicka till översättaren</h2>
                <form>
                    <input type="text" name="" id="trans-text" />
                    <button onClick={this.getTranslation.bind(this)}>Översätt!</button>
                    <div>{this.state.translation}</div>
                </form>
            </main>
        );
    }

    getTranslation = (evt)=> {
        evt.preventDefault();
        //console.log('Tjo!');
        const encodedParams = new URLSearchParams();
        encodedParams.append("q", document.getElementById("trans-text").value);
        encodedParams.append("source","sv");
        encodedParams.append("target","en");

        const options = {
            method: 'POST',
            headers: {
                'content-type': 'application/x-www-form-urlencoded',
                'Accept-Encoding': 'application/gzip',
                'X-RapidAPI-Key': '15de227eeamsh14ac74b0438b36bp1d59d6jsn06435d35c770',
                'X-RapidAPI-Host': 'google-translate1.p.rapidapi.com'
            },
            body: encodedParams
        }

        fetch('https://google-translate1.p.rapidapi.com/language/translate/v2', options).then(response=>response.json()).then(response=> {
            this.setState({translation : response.data.translations[0].translatedText});
        });
    }


}
export default Main;