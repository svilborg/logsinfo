import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios'
import TableRow from './TableRow';
import Table from './Table';

export default class Example extends Component {
	constructor(props) {
	       super(props);
	       this.state = {query: '', items: '', fields: ''};
	}

	componentDidMount() {
	       axios.get('http://localhost:8000/api?type=apachelog')
	       .then(response => {

	    	   console.log("xx");
	    	   console.log(response.data);

	         this.setState({
	        	 items: response.data.data.data,
	        	 fields: response.data.data.fields
	        	 });
	       })
	       .catch(function (error) {
	         console.log(error);
	       })
	 }

	 table() {
		 if(this.state.items instanceof Array) {
			 return <Table items={this.state.items} fields={this.state.fields}/>;
	     }
	 }

//	 handleInputChange () {
//		 this.setState({
//		      query: this.search.value
//		    },
//		    () => {
//		      if (this.state.query && this.state.query.length > 1) {
//		        if (this.state.query.length % 2 === 0) {
//		          this.getInfo()
//		        }
//		      } else if (!this.state.query) {
//		      }
//		    })
//	 }

	 render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Example Component</div>

                            <div className="card-body">
                            <form>
                            <input
                              placeholder="Search for..."
                              ref={input => this.search = input}
                              onChange={this.handleInputChange}
                            /><button onClick={this.handleSearch}> Search </button>
                            </form>

                            <div>
                            <h1>Items</h1>

                            <div className="row">
                              <div className="col-md-10"></div>
                              <div className="col-md-2">

                              </div>
                            </div><br />

                            {this.table()}

                        </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
//<table className="table table-hover">
//<thead>
//<tr>
//    <td>ID</td>
//    <td>Item Name</td>
//    <td>Item Price</td>
//    <td>Actions</td>
//</tr>
//</thead>
//<tbody>
//  {this.tabRow()}
//</tbody>
//</table>