import React from 'react';
import ReactDOM from 'react-dom';

// Import the Autocomplete Component
import Autocomplete from 'react-autocomplete';

export default class SearchUserAndBandsAutoComplete extends React.Component {

    constructor(props, context) {
        super(props, context);

        // Set initial State
        this.state = {
            value: "",
            autocompleteData: [],
        };

        // Bind `this` context to functions of the class
        this.onChange = this.onChange.bind(this);
        this.onSelect = this.onSelect.bind(this);
        this.getItemValue = this.getItemValue.bind(this);
        this.renderItem = this.renderItem.bind(this);
        this.retrieveDataAsynchronously = this.retrieveDataAsynchronously.bind(this);
    }

    /**
     * Updates the state of the autocomplete data with the remote data obtained via AJAX.
     *
     * @param {String} searchText content of the input that will filter the autocomplete data.
     * @return {Nothing} The state is updated but no value is returned
     */
    retrieveDataAsynchronously(searchText){
        let _this = this;

        fetch(`/api/search/${searchText}`)
            .then((response) => {
                if (response.status !== 200) {
                    alert("there has been an error adding the user")
                }

                return response.json();
            })
            .then((data) => {
                let autocompleteData = []
                const bands = data.bands;
                const users = data.users;


                console.log(data);
                for(let user of users) {
                    user.type = "user"
                    autocompleteData.push(user);
                }
                for(let band of bands) {
                    band.type = "band"
                    autocompleteData.push(band);
                }

                _this.setState({
                    autocompleteData: autocompleteData
                })
            })
    }

    /**
     * Callback triggered when the user types in the autocomplete field
     *
     * @param {Event} e JavaScript Event
     * @return {Event} Event of JavaScript can be used as usual.
     */
    onChange(e){
        this.setState({
            value: e.target.value
        });

        this.retrieveDataAsynchronously(e.target.value);
    }

    /**
     * Callback triggered when the autocomplete input changes.
     *
     * @param {Object} val Value returned by the getItemValue function.
     * @return {Nothing} No value is returned
     */
    onSelect(val){}

    /**
     * Define the markup of every rendered item of the autocomplete.
     *
     * @param {Object} item Single object from the data that can be shown inside the autocomplete
     * @param {Boolean} isHighlighted declares wheter the item has been highlighted or not.
     * @return {JSX.Element} Component
     */
    renderItem(item, isHighlighted){
        let key = item.id;
        if(item.type === "band") {
            key += 1 + this.state.autocompleteData.length
        }

        return (
            <div
                className={`item-${item.type}`}
                key={key}
                style={{ background: isHighlighted ? 'lightgray' : 'white' }} >
                {item.name}
            </div>
        );
    }

    getItemValue(item){
        return `${item.id} - ${item.name}`;
    }

    render() {
        return (
                <Autocomplete
                    getItemValue={this.getItemValue}
                    items={this.state.autocompleteData}
                    renderItem={this.renderItem}
                    value={this.state.value}
                    onChange={this.onChange}
                    onSelect={this.onSelect}
                />
        );
    }
}



if (document.getElementById('searchBandUserAutoComplete')) {
    ReactDOM.render(<SearchUserAndBandsAutoComplete />, document.getElementById('searchBandUserAutoComplete'));
}
