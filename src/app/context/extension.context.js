'use client';

import axios from 'axios';
import { createContext, useContext, useEffect, useState } from 'react';

const ExtensionContext = createContext();

export const ExtensionProvider = ({ children }) => {
  // for production
  // const Extension = '.html';

  // for development
  const Extension = '';

  return (
    <ExtensionContext.Provider value={{ Extension }}>
      {children}
    </ExtensionContext.Provider>
  );
};

export const useExtension = () => useContext(ExtensionContext);
