import React, { Component } from 'react';

class TableRow extends Component {
  render() {
    return (

          <td>
            {this.props.obj}
          </td>

    );
  }
}

export default TableRow;