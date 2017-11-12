import React from 'react';
import axios from 'axios';
import Sidebar from './Sidebar';

class SidebarContainer extends React.Component {
  constructor(props) {
    super(props);

    this.handleClick = this.handleClick.bind(this);
    this.fetchStateData = this.fetchStateData.bind(this);

    this.state = {
      ruin: null,
      isLoaded: false,
      language: props.match.params.language,
      ruinSlug: props.match.params.ruin,
      isFormShowing: false,
    };
  }

  componentWillMount() {
    console.log('sidebar - component will mount');
    this.fetchStateData();
  }

  componentWillReceiveProps(nextProps) {
    console.log('sidebar - component will receive props', nextProps);

    this.setState(
      {
        language: nextProps.match.params.language,
        ruinSlug: nextProps.match.params.ruin,
      },
      this.fetchStateData,
    );
  }

  fetchStateData() {
    axios.get(`/api/${this.state.language}/ruins/${this.state.ruinSlug}`).then(response => {
      this.setState({ ruin: response.data, isLoaded: true });
    });
  }

  handleClick() {
    this.setState({ isFormShowing: true });
  }

  render() {
    const { ruin, isFormShowing, isLoaded, language } = this.state;
    return (
      <Sidebar
        ruin={ruin}
        isFormShowing={isFormShowing}
        isLoaded={isLoaded}
        language={language}
        handleClick={this.handleClick}
      />
    );
  }
}

export default SidebarContainer;
