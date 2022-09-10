import React from 'react';
import ReactDOM from 'react-dom';
import Home from './Home.jsx';

if( document.getElementById('reactApp') ){

    ReactDOM.render(
        <Home/>,
        document.getElementById('reactApp')
    );
}