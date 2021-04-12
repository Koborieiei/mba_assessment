import React from "react";
import { TextField, Box } from "@material-ui/core";
import { Controller } from "react-hook-form";
export default function TextAreaFullwidth({ assess }) {
  return (
    <Box component="div" my={3}>
      <Controller
        control={assess}
        name="textbox"
        defaultValue=" "
        render={({ field: { onChange } }) => (
          <TextField
            // name="textbox"
            id="outlined-full-width"
            onChange={onChange}
            label="ข้อเสนอแนะเพิ่มเติม"
            placeholder="เพิ่มข้อเสนอแนะ"
            fullWidth
            multiline
            rows={4}
            InputLabelProps={{
              shrink: true,
            }}
            variant="outlined"
          />
        )}
      />
    </Box>
  );
}
