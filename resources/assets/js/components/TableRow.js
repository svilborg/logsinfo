import React, { Component } from 'react';
import TableRowCell from './TableRowCell';

class TableRow extends Component {

	 tabRowCell() {
		  //if(this.props.obj instanceof Array) {

		 let props = this.props.obj;
		 var data = []

		 Object.keys(props).forEach(function (key) {
			  let obj = props[key];
			  data.push(<TableRowCell obj={obj} key={key}/>)
//			  console.log(obj)
		 });

			  return data;

//			  return this.props.obj.map(function(object, i) {
//				  return <TableRowCell obj={object} key={i} />
//			  })
//		  }
	  }

  render() {
    return (
        <tr>
        {this.tabRowCell()}
        </tr>
    );
  }
}

export default TableRow;

//
//<td>
//{this.props.obj.ip}
//</td>
//<td>
//{this.props.obj.time}
//</td>
//<td>
//	{this.props.obj.code}
//</td>
//<td>
//{this.props.obj.method}
//</td>
//<td>
//	{this.props.obj.path}
//</td>