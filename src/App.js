import Home from "./pages/home";
import { Box, Button, makeStyles, Typography } from "@material-ui/core";

import "./App.css";
import getQueryParams from "./utils/getQueryParam";
import { useState, useEffect } from "react";
import axios from "axios";
const useStyle = makeStyles({
  submitButton: {
    marginTop: 30,
  },
});
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
    // setAuthenticated(true);

    isUserLoggedIn();
  }, []);

  const HomePageConditional = () => {
    const classes = useStyle();
    return authenticated === false ? (
      <Box m={0} mt={20} align="center">
        <Typography align="center" variant="h4">
          กรุณาเข้าสู่ระบบก่อนใช้งาน
        </Typography>
        <Button
          type="button"
          onClick={() => (window.location = process.env.REACT_APP_DOMAIN)}
          size="large"
          variant="contained"
          color="primary"
          className={classes.submitButton}
        >
          เข้าสู่ระบบ
        </Button>
      </Box>
    ) : (
      <Home />
    );
  };

  // console.log(authenticated);

  const { uid, courseid, site } = getQueryParams();

  return (
    <>
      {!courseid || !uid || !site ? (
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
