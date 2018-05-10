
require('./bootstrap');
import React from 'react';
import { render } from 'react-dom';
import { Router, Route, browserHistory } from 'react-router';

console.log("X");

import Example from './components/Example';
import Master from './components/Master';

render(<Example />, document.getElementById('example'));
