import { CssBaseline, ThemeProvider } from "@mui/material";
import { ColorModeContext, useMode } from "../../theme";
import { useContext } from "react";
import { IconButton } from "@mui/material";
import LightModeOutlinedIcon from "@mui/icons-material/LightModeOutlined";
import DarkModeOutlinedIcon from "@mui/icons-material/DarkModeOutlined";
import { useTheme } from "@mui/material/styles";
const Header1 = () => {
  const theme = useTheme();
  const colorMode = useContext(ColorModeContext);
  return (
    <div >
       <div>
      {theme.palette.mode === "light" ? (
        <IconButton
          onClick={() => {
            localStorage.setItem(
              "mode",
              theme.palette.mode === "dark" ? "light" : "dark"
            );
            colorMode.toggleColorMode();
          }}
          color="inherit"
        >
          <LightModeOutlinedIcon />
        </IconButton>
      ) : (
        <IconButton
          onClick={() => {
            localStorage.setItem(
              "mode",
              theme.palette.mode === "dark" ? "light" : "dark"
            );
            colorMode.toggleColorMode();
          }}
          color="inherit"
        >
          <DarkModeOutlinedIcon />
        </IconButton>
      )}
    </div>
    </div>
  );
}
export default Header1;