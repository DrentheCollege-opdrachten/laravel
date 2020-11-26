import React from 'react';
import ReactDOM from 'react-dom';

// Import the Autocomplete Component
import Autocomplete from 'react-autocomplete';

export default class ProfileImageSettings extends React.Component {
    constructor(props, context) {
        super(props, context);
        console.log(props)
    }

    render() {
    return (
        <h3> Lol </h3>
    )
    }
}



if (document.getElementById('react-ProfileImageSettings')) {

    const propsContainer = document.getElementById('react-ProfileImageSettings');
    const props = Object.assign( {}, propsContainer.dataset);

    ReactDOM.render(<ProfileImageSettings {...props}/>, document.getElementById('react-ProfileImageSettings'));
}
