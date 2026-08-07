import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import axios from 'axios';
import Sidebar from './Sidebar';

export default function SidebarContainer() {
  const { language: languageParam, ruin: ruinSlug } = useParams();

  const [ruin, setRuin] = useState(null);
  const [isLoaded, setIsLoaded] = useState(false);
  const [isFormShowing, setIsFormShowing] = useState(false);

  useEffect(() => {
    let active = true;

    setIsLoaded(false);

    axios.get(`/api/${languageParam}/ruins/${ruinSlug}`).then(response => {
      if (active) {
        setRuin(response.data);
        setIsLoaded(true);
        setIsFormShowing(false);
      }
    });

    return () => {
      active = false;
    };
  }, [languageParam, ruinSlug]);

  const handleClick = () => {
    setIsFormShowing(true);
  };

  return (
    <Sidebar
      ruin={ruin}
      isFormShowing={isFormShowing}
      isLoaded={isLoaded}
      language={languageParam}
      handleClick={handleClick}
    />
  );
}
