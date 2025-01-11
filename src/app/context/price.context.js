'use client';

import { createContext, useContext, useEffect, useState } from 'react';
import { useServerLink } from './server.context';
import axios from 'axios';

const PriceContext = createContext();

export const PriceProvider = ({ children }) => {
  const [priceData, setPriceData] = useState(null);

  const { serverLink } = useServerLink();

  useEffect(() => {
    const handlePrice = async () => {
      try {
        const response = await axios.post(
          `${serverLink}/testing/test/gold_rate.php`,
          {
            protectionId: 'Nav##$56',
          }
        );

        // console.log(response.data);
        setPriceData(response.data.record);
      } catch (error) {
        console.log(error);
      }
    };

    handlePrice();

    return () => {};
  }, [serverLink]);

  //   console.log(priceData);

  return (
    <PriceContext.Provider value={{ priceData }}>
      {children}
    </PriceContext.Provider>
  );
};

export const usePrice = () => useContext(PriceContext);
