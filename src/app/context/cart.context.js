'use client';

import { createContext, useContext, useEffect, useState } from 'react';
import { useProfile } from './profile.context';
import axios from 'axios';
import CryptoJS from 'crypto-js';
import { useServerLink } from './server.context';

const CartContext = createContext();

export const CartProvider = ({ children }) => {
  const { userData } = useProfile();
  const [cartData, setCartData] = useState({
    id: '',
    user_id: '',
    product_id: '',
    quantity: 0,
    price: 0,
  });

  const randomNumberInRange = (min, max) => {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  };

  const { serverLink } = useServerLink();

  useEffect(() => {
    if (userData.id) {
      // console.log('user is login');

      const fetchCartData = async () => {
        try {
          const response = await axios.post(
            `${serverLink}/testing/test/fetch_cart.php`,
            {
              userId: userData.id,
              protectionId: 'Nav##$56',
            }
          );

          // console.log(response.data.message);
          // console.log(response.data);

          if (response.data.status === 'success') {
            // reset to default to get only database values
            let newQuantity = 0;
            let newPrice = 0;

            // only to get local cart data also
            // let newQuantity = cartData.quantity;
            // let newPrice = cartData.price;

            response.data.record.map(data => {
              newQuantity = newQuantity + data.quantity;
              newPrice = newPrice + data.price;
            });

            setCartData({
              id: response.data.record[0].id,
              user_id: response.data.record[0].user_id,
              product_id: response.data.record[0].product_id,
              quantity: newQuantity,
              price: newPrice,
            });

            // console.log('price get updated');
          } else if (response.data.status === 'error') {
            setCartData({
              id: '',
              user_id: userData.id,
              product_id: '',
              quantity: 0,
              price: 0,
            });

            // console.log('only user_id get updated');
          }
        } catch (error) {
          console.log(error);
        }
      };

      fetchCartData();
    } else {
      // console.log('user is not login');

      // const saveLocalCart = localStorage.getItem('cart');

      // // if local cart is empty it will created and put cartData default value to it
      // if (!saveLocalCart) {
      //   console.log('cart is not set in local');
      //   localStorage.setItem('cart', JSON.stringify(cartData));
      // } else {
      //   // setCartData(JSON.parse(saveLocalCart));
      // }

      // console.log(JSON.parse(saveLocalCart));

      const offlineCart = localStorage.getItem('localCart');

      // if local cart is empty it will created and put cartData default value to it
      if (!offlineCart) {
        const randomNumber = randomNumberInRange(100, 200);
        const timestamp = new Date().toISOString();
        const rawString = `${randomNumber}_${timestamp}`;
        const hashedSessionId = CryptoJS.SHA256(rawString).toString();

        // console.log({
        //   randomNumber: randomNumber,
        //   hashedSessionId: hashedSessionId,
        // });

        // console.log('localcart is not set in local');
        localStorage.setItem('localCart', JSON.stringify(hashedSessionId));
      } else {
        const hashedLocalUserId = JSON.parse(localStorage.getItem('localCart'));

        const fetchLocalCartData = async () => {
          try {
            const response = await axios.post(
              `${serverLink}/testing/local-cart/get_local-cart.php`,
              {
                userId: hashedLocalUserId,
                protectionId: 'Nav##$56',
              }
            );

            // console.log(response.data.message);
            // console.log(response.data);

            if (response.data.status === 'success') {
              // reset to default to get only database values
              let newQuantity = 0;
              let newPrice = 0;

              // only to get local cart data also
              // let newQuantity = cartData.quantity;
              // let newPrice = cartData.price;

              response.data.record.map(data => {
                newQuantity = newQuantity + data.quantity;
                newPrice = newPrice + data.price;
              });

              setCartData(val => ({
                ...val,
                quantity: newQuantity,
                price: newPrice,
              }));

              // console.log('local cart price get updated');
            }
          } catch (error) {
            console.log(error);
          }
        };

        fetchLocalCartData();
      }
    }
  }, [userData.id, serverLink]);

  return (
    <CartContext.Provider value={{ cartData, setCartData }}>
      {children}
    </CartContext.Provider>
  );
};

export const useCart = () => useContext(CartContext);
