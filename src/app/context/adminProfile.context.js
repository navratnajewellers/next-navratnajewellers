'use client';

import { createContext, useContext, useState } from 'react';

const AdminProfileContext = createContext();

export const AdminProfileProvider = ({ children }) => {
  // const [profile, setProfile] = useState(false);
  const [adminData, setAdminData] = useState({
    id: '',
    username: '',
  });

  return (
    <AdminProfileContext.Provider value={{ adminData, setAdminData }}>
      {children}
    </AdminProfileContext.Provider>
  );
};

export const useAdminProfile = () => useContext(AdminProfileContext);
