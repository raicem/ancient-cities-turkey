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
    this.fetchStateData();
  }

  componentWillReceiveProps(nextProps) {
    console.log('component will receive props');
    const { language, ruin } = nextProps.match.params;

    if (this.state.language !== language || this.state.ruinSlug !== ruin) {
      this.setState(
        {
          language: nextProps.match.params.language,
          ruinSlug: nextProps.match.params.ruin,
          isLoaded: false,
        },
        this.fetchStateData,
      );
    }
  }

  async fetchStateData() {
    const response = await axios.get(`/api/${this.state.language}/ruins/${this.state.ruinSlug}`);
    this.setState({ ruin: response.data, isLoaded: true, isFormShowing: false });
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
