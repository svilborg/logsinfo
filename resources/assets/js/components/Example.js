import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios'
import TableRow from './TableRow';
import Table from './Table';

export default class Example extends Component {
	constructor(props) {
	       super(props);
	       this.state = {query: '', items: '', fields: '', ltype: 'apachelog', data : ''};

	       this.changeType = this.changeType.bind(this);
	       this.loadTable = this.loadTable.bind(this)
	}

	componentDidMount() {
		this.loadTable()
	 }

	 loadTable(l) {
		 console.log(this.state.ltype)
	       axios.get('http://localhost:8000/api?type='+l)
	       .then(response => {

	         this.setState({
	        	 items: response.data.data.data,
	        	 fields: response.data.data.fields,
	        	 data: response.data.data
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

	 tableSummary(f) {
		 let fields = ["name", "count", "percent"]

		 console.log(this.state.data[f])

		 if(this.state.items instanceof Array) {
			 return <Table items={this.state.data[f]} fields={fields}/>;
	     }
	 }


	 changeType (event) {
		 let e = event.target.value

		 this.loadTable(e)
         this.setState({ltype: e});
	 }

	 render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Example Component</div>

                            <div className="card-body">

                            <form>
	                            <select id="lang" onChange={this.changeType} value={this.state.ltype}>
	                            <option value="apachelog" selected>apachelog</option>
	                            <option value="syslog" >syslog</option>
	                            </select>
                            </form>

                            <img src="http://localhost:8000/api/chart?type=syslog&field=hour"/>



                            <div>
                            <h1>Log Data</h1>

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