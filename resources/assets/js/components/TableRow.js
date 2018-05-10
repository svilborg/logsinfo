import React, { Component } from 'react';

class TableRow extends Component {
  render() {
    return (
        <tr>
          <td>
            {this.props.obj.ip}
          </td>
          <td>
            {this.props.obj.time}
          </td>
          <td>
          	{this.props.obj.code}
          </td>
          <td>
          {this.props.obj.method}
          </td>
          <td>
          	{this.props.obj.path}
          </td>
        </tr>
    );
  }
}

export default TableRow;