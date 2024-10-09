import { Component } from 'react';

class Main extends Component{

  constructor(props){
    super(props);

    let {r, g, b} = this.props;

    this.state = {
      red: r,
      green: g,
      blue: b
    }

    this.state.time = 0;
    this.state.showTime = true;

    this.startTimer();

    console.log(this.props);
  }


  startTimer = () => {
    setInterval(() => {
      
      this.setState((prevState) => ({
        time: prevState.time + 1
      }));

      //this.randomColor();
    }, 1000);
  }


  randomColor = () => {
    this.red = Math.floor(Math.random() * 255);
    this.green = Math.floor(Math.random() * 255);
    this.blue = Math.floor(Math.random() * 255);

    /*this.state = {
      red: this.red,
      blue: this.blue,
      green: this.green
    }
      */

    this.setState({
      red: this.red,
      blue: this.blue,
      green: this.green
    });

    console.log(this.state)
  }




  
  render() {
    let css ={
      height: 300 + "px",
      backgroundColor: "rgb(" + this.state.red + ", " + this.state.green + ", " + this.state.blue + ")"
    }

    return (
      <main style={css}>
        <h1>Detta är main</h1>
        {this.state.showTime && <p>Tiden är nu: {this.state.time}</p>}
        <button onClick={this.randomColor}>Byt färg</button>
      </main>
    )
  }
}



export default Main;