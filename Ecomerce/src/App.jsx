import React, { useContext } from 'react';
import Header1 from './components/header/Header1';
import Header2 from './components/header/Header2';
import Header3 from './components/header/Header3';
import { CssBaseline, ThemeProvider } from "@mui/material";
import { ColorModeContext, useMode } from "./theme";

function App() {
 const [theme, colorMode] = useMode();
  return (
     <ColorModeContext.Provider value={colorMode}>
     <ThemeProvider theme={theme}>
        <CssBaseline />
     <h1>Welcome to Ecomerce</h1>
     <Header1 />
     <Header2 />
     <Header3 />
   </ThemeProvider>
   </ColorModeContext.Provider>
  )
}

export default App
