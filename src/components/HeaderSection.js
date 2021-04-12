import React from "react";
import { makeStyles } from "@material-ui/core/styles";
import Box from "@material-ui/core/Box";
import { Typography } from "@material-ui/core";

const useStyles = makeStyles((theme) => ({
  root: {
    "& > *": {
      margin: theme.spacing(1),
    },
  },
}));

export default function HeaderSection({ courseshortname }) {
  const classes = useStyles();
  return (
    <Box className={classes.root} component="section" p={"2px"} color="black">
      <Typography variant="h4" component="h4">
        ประเมินอาจารย์ประจำวิชา {courseshortname}
      </Typography>
      <Typography component="span">
        การประเมินความคิดเห็นของนักศึกษาต่อ
      </Typography>
    </Box>
  );
}
