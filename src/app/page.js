'use client';

import Link from 'next/link';
import { useExtension } from './context/extension.context';

export default function Home() {
  const { Extension } = useExtension();
  console.log('Extension are : ', Extension);

  return (
    <div>
      Home page
      <h2>
        <Link href={`/page/AboutUs${Extension}`} target="_blank">
          About Us
        </Link>
      </h2>
    </div>
  );
}
