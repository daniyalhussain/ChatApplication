import React, {Component} from 'react';
import Loader from 'react-loader-spinner'
import PropTypes from "prop-types";

class Messages extends Component {
  state = {
    isLoading: true,
    messages: [],
    m: ""
  }

  static propTypes = {
    openChat: PropTypes.string.isRequired,
  }

  componentDidMount() {
    this.getMessages();
    this.interval = setInterval(() => this.fetchMessages(), 500);
  }

  componentWillUnmount() {
    clearInterval(this.interval);
  }

  componentWillReceiveProps(nextProps) {
    if (nextProps.openChat != this.props.openChat) {
      this.getMessages(nextProps.openChat);
    }
  }

  getMessages(openChat=this.props.openChat) {

    this.setState({
      isLoading: true
    });

    this.fetchMessages(openChat)
  }

  fetchMessages(openChat=this.props.openChat) {
    fetch("/api/getchatmessages.php", {
      method: 'post',
      body:
        JSON.stringify({
          "chat": openChat
        })

    })
      .then(res => res.json())
      .then(
        (result) => {
          this.setState({
            isLoading: false,
            messages: result
          });
        },

        (error) => {
          this.setState({
            isLoading: false,
            error
          });
        }
      )
  }

  sendMessage() {
    const { openChat } = this.props;
    const { m } = this.state;

    if(m == null) {
      return;
    }

    this.setState({ m: "" });

    fetch("/api/postchatmessage.php", {
      method: 'post',
      body:
        JSON.stringify({
          "chat": {
            "message": m,
            "chat": openChat
          }
        })

    })
      .then(res => res.json())
      .then(
        (result) => {
          this.setState({
            isLoading: false,
            messages: result
          });
        },
        (error) => {
          this.setState({
            isLoading: false,
            error
          });
        }
      )
  }

  renderMessage(message) {
    return (
      <div className="message" key={message.id}>
        <b>{message.user.name}:</b><br/>
        {message.message}
      </div>
    );
  }

  render() {
    const { isLoading, messages, m } = this.state;

    if (isLoading) {
      return (
        <div className="loader mx-auto">
          <Loader
          type="Puff"
          color="#00BFFF"
          height={100}
          width={100}
          />
        </div>
      );
    }

    return (
      <div className="col-12 col-md-9 chatbox">
        <div className="messages">

        </div>
        <div className="chat-messages">
          {messages.map((message) => {
            return this.renderMessage(message);
          })}

          <div className="row mt-5">
            <div className="col-10">
              <input type="message" className="form-control" value={m} onChange={mes => this.setState({ m: mes.target.value })}/>
            </div>

            <div className="col-2">
              <button className="btn btn-primary" onClick={() => this.sendMessage()}>send</button>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

export default Messages;