import React, { Component } from 'react';

class TableColumn extends Component {
  render() {
    return (

          <td>
            {this.props.obj}
          </td>

    );
  }
}

export default TableColumn;