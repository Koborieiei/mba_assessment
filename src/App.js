import Home from "./pages/home";
import "./App.css";
import getQueryParams from "./utils/getQueryParam";

function App() {
  const { uid, courseid } = getQueryParams();

  return (
    <> {!courseid || !uid ? <> error not found </> : <Home />} </>
    // <>{getQueryParams().uid === undefined ? <> Not found 404</> : <Home />}</>
  );
}

export default App;
