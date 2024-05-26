import { Outlet } from "react-router-dom";

import Nav from "../../Components/UI/Nav";
import Footer from "../../Components/UI/Footer";

const Root = () => {
  return (
    <>
      <Nav />
      <Outlet />
      <Footer />
    </>
  );
};

export default Root;
