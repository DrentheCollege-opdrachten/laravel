import React from 'react';
import ReactDOM from 'react-dom';

// Import the Autocomplete Component
import Autocomplete from 'react-autocomplete';

export default class Example extends React.Component {

    constructor(props, context) {
        super(props, context);
    }

    render() {
        return (
            <h3> Example </h3>
        );
    }
}



if (document.getElementById('react-example')) {
    ReactDOM.render(<Example />, document.getElementById('react-example'));
}
