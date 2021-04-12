import React from "react";
import {
  Select,
  Typography,
  Card,
  CardContent,
  FormControl,
  InputLabel,
} from "@material-ui/core";
import { makeStyles } from "@material-ui/core/styles";

import { Controller } from "react-hook-form";

const useStyles = makeStyles((theme) => ({
  root: {
    minWidth: 275,
    marginTop: 20,
  },
  selectElement: {
    marginTop: 15,
  },
  //   formControl: {
  //     // width: 30,
  //     height: 200,
  //   },
  title: {
    fontSize: 24,
  },
}));

const SelectLists = ({ teacherLists }) => {
  return teacherLists.map((teacher, index) => {
    return (
      <option value={teacher[0]} key={index}>
        {teacher[1]} {teacher[2]}
      </option>
    );
  });
};

export default function TeacherSelector({ assess, teacherLists }) {
  const classes = useStyles();
  return (
    <Card className={classes.root}>
      <CardContent>
        <Typography className={classes.title} gutterBottom>
          เลือกอาจารย์ผู้สอน
        </Typography>
        <Controller
          render={({
            field: { onChange, onBlur, name, ref, value },
            fieldState: { invalid, isTouched, isDirty, error },
            formState,
          }) => (
            <FormControl variant="outlined" fullWidth={true}>
              <InputLabel
                className={classes.selectElement}
                htmlFor="age-native-simple"
              >
                อาจารย์ผู้สอน
              </InputLabel>
              <Select
                native
                className={classes.selectElement}
                value={value}
                onChange={onChange}
                label="อาจารย์ผู้สอน"
              >
                <option value="" aria-label="none" />
                <SelectLists teacherLists={teacherLists} />
              </Select>
            </FormControl>
          )}
          control={assess}
          name="selectedteacher"
          defaultValue=""
        />
      </CardContent>
    </Card>
  );
}
