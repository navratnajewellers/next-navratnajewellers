'use client';

import axios from 'axios';
import { createContext, useEffect } from 'react';
import { useServerLink } from './server.context';

const DeleteAndVersionContext = createContext();

export const DeleteAndVersionProvider = ({ children }) => {
  const { serverLink } = useServerLink();

  useEffect(() => {
    // console.log('Inside the auto delete and version check component');

    // auto delete the old data greater than 30 days in local cart will be get deleted
    const autoDeleteLocalCartData = async () => {
      try {
        const response = await axios.post(
          `${serverLink}/testing/local-cart/auto-delete-local-cart.php`,
          {
            protectionId: 'Nav##$56',
          }
        );

        if (response.status === 200) {
          // console.log(response.data.message);
          // console.log(response.data);
        }
      } catch (error) {
        console.log(error);
      }
    };

    autoDeleteLocalCartData();

    // save the version of production for force reload the user to get latest css and javascript file

    const getBuildVersion = async () => {
      try {
        const response = await axios.post(
          `${serverLink}/testing/test/get_build_version.php`,
          {
            protectionId: 'Nav##$56',
          }
        );

        if (response.status === 200 && response.data.status == 'success') {
          // console.log(response.data.message);
          // console.log(response.data);

          const saveBuildVersion = localStorage.getItem('nav-build-version');

          // if build version is empty it will created and put version data to it
          if (!saveBuildVersion) {
            // console.log('build version is not set');
            localStorage.setItem(
              'nav-build-version',
              JSON.stringify(response.data.version)
            );
          }

          // checking the version of local storage and database build version
          const localBuildVersion = JSON.parse(saveBuildVersion);

          if (localBuildVersion !== response.data.version) {
            // set the build version from the database to local storage data
            localStorage.setItem(
              'nav-build-version',
              JSON.stringify(response.data.version)
            );
            window.location.reload(true);
          }
        }
      } catch (error) {
        console.log(error);
      }
    };

    getBuildVersion();
  }, [serverLink]);

  return (
    <DeleteAndVersionContext.Provider value={{}}>
      {children}
    </DeleteAndVersionContext.Provider>
  );
};
