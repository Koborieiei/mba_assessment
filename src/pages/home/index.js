import React from "react";
import Helmet from "react-helmet";
import FormSection from "../../components/FormSection";

import Container from "@material-ui/core/Container";
function Home() {

  return (
    <>
      <Helmet>
        <title>ประเมินอาจารย์รายวิชา - UTCC : MBA Online </title>
      </Helmet>
      <Container maxWidth="md">
        <FormSection />
      </Container>
    </>
  );
}

export default Home;
