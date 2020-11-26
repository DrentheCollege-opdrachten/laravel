import React from 'react';
import ReactDOM from 'react-dom';

// Import the Autocomplete Component
import Autocomplete from 'react-autocomplete';

export default class BandSettingsUserSearchAutoComplete extends React.Component {

    constructor(props, context) {
        super(props, context);

        console.log(this.props)

        // Set initial State
        this.state = {
            // Current value of the select field
            value: "",
            // Data that will be rendered in the autocomplete
            // As it is asynchronous, it is initially empty
            autocompleteData: [],
            selectedVal: '',
            members: [],
        };

        this.getBandMembers();
        // Bind `this` context to functions of the class
        this.onChange = this.onChange.bind(this);
        this.onSelect = this.onSelect.bind(this);
        this.getItemValue = this.getItemValue.bind(this);
        this.renderItem = this.renderItem.bind(this);
        this.retrieveDataAsynchronously = this.retrieveDataAsynchronously.bind(this);
    }

    getBandMembers() {
        let bandId = window.location.pathname.split('/')[2];
        const _this = this;
        fetch(`/api/band/${bandId}/getUsers`)
            .then((response) => {
                if(response.status !== 200) {
                    console.log('There has been a error')
                }

                return response.json();
            })
            .then((data) => {
                _this.setState({
                    members: data
                })
            })

    }


    /**
     * Updates the state of the autocomplete data with the remote data obtained via AJAX.
     *
     * @param {String} searchText content of the input that will filter the autocomplete data.
     * @return {Nothing} The state is updated but no value is returned
     */
    retrieveDataAsynchronously(searchText){
        let _this = this;

        fetch(`/api/search/user/email/${searchText}`)
            .then((response) => {
                if (response.status !== 200) {
                    alert("there has been an error adding the user")
                }

                return response.json();
            })
            .then((data) => {
                _this.setState({
                    autocompleteData: data
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

        /**
         * Handle the remote request with the current text !
         */
        this.retrieveDataAsynchronously(e.target.value);

    }

    /**
     * Callback triggered when the autocomplete input changes.
     *
     * @param {Object} val Value returned by the getItemValue function.
     * @return {Nothing} No value is returned
     */
    onSelect(val){
        let splitBySpace = val.split(" ")
        let userId = splitBySpace[0];
        let showName = splitBySpace.slice(2, splitBySpace.length).join(" ");

        this.setState({
            value: showName,
            selectedVal: userId
        });
    }

    /**
     * Define the markup of every rendered item of the autocomplete.
     *
     * @param {Object} item Single object from the data that can be shown inside the autocomplete
     * @param {Boolean} isHighlighted declares wheter the item has been highlighted or not.
     * @return {JSX.Element} Component
     */
    renderItem(item, isHighlighted){
        return (
            <div className="item" key={item.id} style={{ background: isHighlighted ? 'lightgray' : 'white' }}>
                {item.email}
            </div>
        );
    }

    /**
     * Define which property of the autocomplete source will be show to the user.
     *
     * @param {Object} item Single object from the data that can be shown inside the autocomplete
     * @return {String} val
     */
    getItemValue(item){
        // You can obviously only return the Label or the component you need to show
        // In this case we are going to show the value and the label that shows in the input
        // something like "1 - Microsoft"
        return `${item.id} - ${item.email}`;
    }

    addUser(e) {
        e.preventDefault()

        const bandId = window.location.pathname.split('/')[2];
        const user_id = this.state.selectedVal;

        if (user_id === "") {return alert("please select a user")}
        console.log(bandId, user_id);

        const csrfToken = document.querySelector("[name='csrf-token']").getAttribute('content');
        fetch(`/band/${bandId}/addUser/${user_id}`, {
            method: 'post',
            headers: {
                'x-csrf-token': csrfToken
            }
        }).then((response) => {
            if (response.status !== 200) {
                return alert('there was an error adding the new member');
            }

            this.getBandMembers();
        })
    }

    deleteMember(e) {
        e.preventDefault();
        const bandId = window.location.pathname.split('/')[2];
        const userId = e.target.dataset.id;
        const csrfToken = document.querySelector("[name='csrf-token']").getAttribute('content');
        fetch(`/band/${bandId}/deleteUser/${userId}`, {
            method: 'delete',
            headers: {
                'x-csrf-token': csrfToken
            },
        }).then((response) => {
            if(response.status !== 200) {
                return alert('there has been an error with deleting the member')
            }

            this.getBandMembers();
        })
    }
    renderMenu(items, value, style) {
        return (
            <div style={{ ...style, ...this.menuStyle }} children={items}/>
        )
    }


    render() {
        return (
            <div>
                <div style={{
                    marginBottom: "30px"
                }}>

                    <Autocomplete
                        getItemValue={this.getItemValue}
                        items={this.state.autocompleteData}
                        renderItem={this.renderItem}
                        value={this.state.value}
                        onChange={this.onChange}
                        onSelect={this.onSelect}
                        renderMenu={this.renderMenu.bind(this)}
                    />
                    <button
                        className={"btn float-right mr-3"}
                        onClick={this.addUser.bind(this)}
                        type={"button"}>
                        Add User
                    </button>
                </div>
                <div>
                    <ul className={"list-group list-group col-md-12"}>
                        <li className={"list-group-item active d-flex align-items-center"}
                                style={{
                                    backgroundColor: "var(--text-color, #3490dc)",
                                    borderColor: "var(--text-color, #3490dc)",
                                    color: "var(--background-color, white)"
                                }}>
                            <div className={"h5"}
                                 style={{marginBottom: "0px"}}>

                            Current members
                            </div>
                        </li>
                        {
                            this.state.members.map((val, index) => {
                                console.log(this.props, val.id);
                                if (val.id == this.props.userid) {
                                    return (
                                        <li key={index} className={"list-group-item d-flex align-items-center"}
                                            style={{
                                                backgroundColor: "var(--background-color, #3490dc)",
                                                borderColor: "var(--text-color, #3490dc)",
                                                color: "var(--text-color, white)"
                                            }}>
                                            <div
                                                className={"h5"}
                                                style={{marginBottom: "0px"}}>
                                                    {val.name}
                                            </div>
                                        </li>
                                    )
                                }
                                return(
                                    <li key={index} className={"list-group-item"}
                                        style={{
                                            backgroundColor: "var(--background-color, #3490dc)",
                                            borderColor: "var(--text-color, #3490dc)",
                                            color: "var(--text-color, white)"
                                        }}>
                                        <form data-id={val.id} className={"d-flex justify-content-between align-items-center"} onSubmit={this.deleteMember.bind(this)}>
                                            <div className={"h5"}
                                                 style={{marginBottom: "0px"}}>
                                                {val.name}
                                            </div>
                                            <button type={"submit"} className={"btn float-right mr-2"}> delete </button>
                                        </form>
                                    </li>)
                            })
                        }
                    </ul>
                </div>

            </div>
        );
    }
}



if (document.getElementById('bandSettingsAutoComplete')) {


    const propsContainer = document.getElementById('bandSettingsAutoComplete');
    const props = Object.assign( {}, propsContainer.dataset);

    ReactDOM.render(<BandSettingsUserSearchAutoComplete {...props}/>, document.getElementById('bandSettingsAutoComplete'));
}
