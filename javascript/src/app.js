import React, { Component, Fragment } from 'react';
import { render } from 'react-dom';
import UserChats from "./components/UserChats";
import Messages from "./components/Messages";


class Myapp extends Component {
  state = {
    openChat: 1
  }

  changeChat = (chat) =>  {
    this.setState({
      openChat: chat
    })

  }

  render() {
    const { openChat } = this.state;

    return (
      <Fragment>
        <div className="container-fluid">
          <div className="row">
            <UserChats changeChat={this.changeChat}/>

            <Messages openChat={openChat} />
          </div>
        </div>
      </Fragment>
  )
  }
}

render(<Myapp/>, document.getElementById('app'));