'use client';

import { useServerLink } from '@/app/context/server.context';

export default function AboutUs() {
  const { serverLink } = useServerLink();

  console.log(serverLink);

  return <div>About us page</div>;
}
