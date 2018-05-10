import React, { Component } from 'react';
import TableRow from './TableRow';
import TableColumn from './TableColumn';

class Table extends Component {

  tabColumn() {
	  console.log(this.props.fields)
		 if(this.props.fields instanceof Array) {
	         return this.props.fields.map(function(object, i) {
	             return <TableColumn obj={object} key={i} />;
	         })
	     }
  }

  tabRow() {
	  if(this.props.items instanceof Array) {
		  return this.props.items.map(function(object, i) {
			  return <TableRow obj={object} key={i} />
		  })
	  }
  }

  render() {
    return (
        <table className="table table-hover">
          <thead>
          <tr>
          	{this.tabColumn()}

          </tr>
          </thead>
          <tbody>
          {this.tabRow()}
          </tbody>
      </table>

    );
  }
}

export default Table;