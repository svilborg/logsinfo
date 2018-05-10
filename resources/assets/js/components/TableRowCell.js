import React, { Component } from 'react';

class TableRowCell extends Component {
  render() {
    return (

          <td>
            {this.props.obj}
          </td>

    );
  }
}

export default TableRowCell;