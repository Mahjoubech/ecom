import * as React  from 'react';
import { CssBaseline, ThemeProvider, Typography } from "@mui/material";
import { ColorModeContext, useMode } from "../../theme";
import { useContext , useState } from "react";
import { IconButton } from "@mui/material";
import LightModeOutlinedIcon from "@mui/icons-material/LightModeOutlined";
import DarkModeOutlinedIcon from "@mui/icons-material/DarkModeOutlined";
import { useTheme } from "@mui/material/styles";
import { Box, Container, Stack } from "@mui/system";
import { ExpandMore, Fullscreen } from "@mui/icons-material";
import FacebookIcon from '@mui/icons-material/Facebook';
import TwitterIcon from '@mui/icons-material/Twitter';
import InstagramIcon from '@mui/icons-material/Instagram';
import List from '@mui/material/List';
import ListItemButton from '@mui/material/ListItemButton';
import ListItemText from '@mui/material/ListItemText';
import MenuItem from '@mui/material/MenuItem';
import Menu from '@mui/material/Menu';
const options = [
  'EN',
  'AR',

];
const Header1 = () => {
  const theme = useTheme();
  const colorMode = useContext(ColorModeContext);
   const [anchorEl, setAnchorEl] = useState(null);
  const [selectedIndex, setSelectedIndex] = useState(1);
  const open = Boolean(anchorEl);
  const handleClickListItem = (event) => {
    setAnchorEl(event.currentTarget);
  };

  const handleMenuItemClick = (
    event,
    index,
  ) => {
    setSelectedIndex(index);
    setAnchorEl(null);
  };

  const handleClose = () => {
    setAnchorEl(null);
  };
  return (
    <Box sx = {{ 
        bgcolor:"#2B3445",
        py: "4px",
        borderBottomLeftRadius:4,
        borderBottomRightRadius:4, 
        }}>
          <Container>
<Stack width={"100%"} direction={"row"} alignItems={"center"} spacing={2}>
    <Typography 
            sx = {{
                mr : 2,
                p:"3px 10px",
                bgcolor: "#D23F57",
                fontSize: "10px",
                fontWeight: "bold",
                color: "#fff",
            }}
            >
HOT
            </Typography>
             <Typography 
            sx = {{
                fontSize: "12px",
                fontWeight: 300,
                color: "#fff",
            }}
            >
Free Express Shipping
            </Typography>


            <Box flexGrow={1} />

       <div>
      {theme.palette.mode === "light" ? (
        <IconButton
          onClick={() => {
            localStorage.setItem(
              "mode",
              theme.palette.mode === "dark" ? "light" : "dark"
            );
            colorMode.toggleColorMode();
          }}        >
          <LightModeOutlinedIcon sx={{ fontSize: "15px", color: "#fff" }} />
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
          <DarkModeOutlinedIcon sx={{ fontSize: "15px" }}  />
        </IconButton>
      )}
    </div>
    
         <List
        component="nav"
        aria-label="Device settings"
          sx ={{ p:0,m:0}}
      >
        <ListItemButton
          id="lock-button"
          aria-haspopup="listbox"
          aria-controls="lock-menu"
          aria-label="when device is locked"
          aria-expanded={open ? 'true' : undefined}
          onClick={handleClickListItem}
          sx={{ "&:hover": { cursor: "pointer", px: 1 } }}
        >
          <ListItemText
            sx={{ ".MuiTypography-root": { fontSize: "10px", color: "#fff" } }}
            secondary={options[selectedIndex]}
          
          />
          <ExpandMore sx={{ color: "#fff", fontSize: "16px" }} />

        </ListItemButton>
      </List>
      <Menu
        id="lock-menu"
        anchorEl={anchorEl}
        open={open}
        onClose={handleClose}
        MenuListProps={{
          'aria-labelledby': 'lock-button',
          role: 'listbox',
        }}
      >
        {options.map((option, index) => (
          <MenuItem
          sx={{ fontSize: "10px", color: "#fff",p:"3px 10px",minHeight:"10px"}}
            key={option}
            selected={index === selectedIndex}
            onClick={(event) => handleMenuItemClick(event, index)}
          >
            {option}
          </MenuItem>
        ))}
      </Menu>

<FacebookIcon sx = {{ color: "#fff", fontSize: "16px"}} />
<TwitterIcon sx = {{ color: "#fff", fontSize: "16px", mx: 1}} />
<InstagramIcon sx = {{ color: "#fff", fontSize: "16px"}} />
  </Stack>
          </Container>
          
        
    </Box>
  );
}
export default Header1;