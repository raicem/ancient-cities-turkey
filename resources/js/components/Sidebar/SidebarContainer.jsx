import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import axios from 'axios';
import Sidebar from './Sidebar';

export default function SidebarContainer() {
  const { language: languageParam, ruin: ruinSlug } = useParams();

  const [ruin, setRuin] = useState(null);
  const [isLoaded, setIsLoaded] = useState(false);
  const [hasLoadError, setHasLoadError] = useState(false);
  const [isFormShowing, setIsFormShowing] = useState(false);
  const [requestVersion, setRequestVersion] = useState(0);

  useEffect(() => {
    let active = true;

    setIsLoaded(false);
    setHasLoadError(false);

    axios
      .get(`/api/${languageParam}/ruins/${ruinSlug}`)
      .then(response => {
        if (active) {
          setRuin(response.data);
          setIsLoaded(true);
          setIsFormShowing(false);
        }
      })
      .catch(() => {
        if (active) {
          setHasLoadError(true);
        }
      });

    return () => {
      active = false;
    };
  }, [languageParam, ruinSlug, requestVersion]);

  const handleClick = () => {
    setIsFormShowing(true);
  };

  const handleRetry = () => {
    setRequestVersion(version => version + 1);
  };

  return (
    <Sidebar
      ruin={ruin}
      isFormShowing={isFormShowing}
      isLoaded={isLoaded}
      hasLoadError={hasLoadError}
      language={languageParam}
      handleClick={handleClick}
      handleRetry={handleRetry}
    />
  );
}
