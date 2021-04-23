import Home from "./pages/home";
import { Box, Button } from "@material-ui/core";

import "./App.css";
import getQueryParams from "./utils/getQueryParam";
import { useState, useEffect } from "react";
import axios from "axios";

function App() {
  const isUserLoggedIn = async () => {
    try {
      const url = "../lms/local/getuserinfo.php";

      const req = await axios.get(url);

      if (req.data.code === 200) {
        setAuthenticated(true);
      }
    } catch (error) {
      console.log(error);
    }
  };

  const [authenticated, setAuthenticated] = useState(false);

  useEffect(() => {
    isUserLoggedIn();
  }, []);

  const HomePageConditional = () => {
    console.log(authenticated);
    return authenticated === false ? (
      <Box m={0} mt={20} align="center">
        กรุณาเข้าสู่ระบบก่อนใช้งาน
        <a href="http://mbaonline.utcc.ac.th/lms/">
          <Button> เข้าสู่ระบบ</Button>
        </a>
      </Box>
    ) : (
      <Home />
    );
  };

  // console.log(authenticated);

  const { uid, courseid } = getQueryParams();

  return (
    <>
      {!courseid || !uid ? (
        <Box m={0} mt={20} align="center">
          ขออภัยระบบเกิดข้อผิดพลาด..
          {(window.location = "http://mbaonline.utcc.ac.th/lms/")}
        </Box>
      ) : (
        <HomePageConditional />
      )}
    </>
    // <>{getQueryParams().uid === undefined ? <> Not found 404</> : <Home />}</>
  );
}

export default App;
