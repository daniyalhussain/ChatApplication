import React, {Component} from 'react';
import Loader from "react-loader-spinner";

import PropTypes from 'prop-types';

class UserChats extends Component {
  state = {
    isLoading: true,
    chats: []
  }

  static propTypes = {
    changeChat: PropTypes.func.isRequired,
  }

  componentDidMount() {
    fetch("/api/getchats.php")
      .then(res => res.json())
      .then(
        (result) => {

          this.setState({
            isLoading: false,
            chats: result
          });
        },
        // Note: it's important to handle errors here
        // instead of a catch() block so that we don't swallow
        // exceptions from actual bugs in components.
        (error) => {
          this.setState({
            isLoading: false,
            error
          });
        }
      )
  }

  renderChats(chat) {
    return (
      <div className="chat" key={chat.id} onClick={() => this.props.changeChat(chat.id)}>
        <b>chat: {chat.creator.name} - {chat.participant.name}</b>
      </div>
    );
  }

  render() {
    const { isLoading, chats } = this.state;

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
      <div className="col-12 col-md-3 chats">
        <div className="chat-block">
          {chats.map((chat) => {
            return this.renderChats(chat);
          })}
        </div>
      </div>
    );
  }
}

export default UserChats;